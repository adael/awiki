<?php

class WikiPage extends WikiAppModel
{

    public $hasOne = array(
        'WikiMenu' => array(
            'className' => 'Wiki.WikiMenu',
            'foreignKey' => false,
            'conditions' => 'WikiMenu.page_alias = WikiPage.alias',
        ),
    );

    public $validate = array(
        'alias' => array(
            'rule' => '/^[' . WikiUtil::WIKI_PAGE_ALIAS_ALLOWED_CHARS . ']+$/',
            'message' => 'Invalid page alias',
        ),
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'Title cannot be empty',
        ),
    );

    /**
     * saves the old alias to rename in all pages in case of change.
     * @var null
     */
    private $old_alias = null;

    public function beforeValidate($options = array())
    {
        $this->prepareAlias();
        $this->checkDuplicatedAlias();
        $this->prepareContent();
        return parent::beforeValidate($options);
    }

    public function beforeSave($options = array())
    {
        if ($this->id) {
            $this->old_alias = $this->field('alias');
        } else {
            $this->old_alias = null;
        }
        return parent::beforeSave($options);
    }

    public function afterSave($created, $options = array())
    {
        if ($this->old_alias) {
            $this->renameAlias($this->old_alias, $this->value('alias'));
        }
        $this->old_alias = null;
        return parent::afterSave($created, $options);
    }

    public function beforeDelete($cascade = true)
    {
        if ($this->field('internal')) {
            $this->invalidate('internal', __("You cannot delete this page because it's a system page"));
            return false;
        }
        return parent::beforeDelete($cascade);
    }

    public function setPageLock($alias, $locked)
    {
        return $this->updateAll(compact('locked'), compact('alias'));
    }

    public function embedPages(&$page)
    {
        $matches = null;
        $n = preg_match_all('/\{\#([' . WikiUtil::WIKI_PAGE_ALIAS_ALLOWED_CHARS . ']+)\#\}/', $page[$this->alias]['content'], $matches);
        if ($n) {
            $res = $this->find('list', array(
                'fields' => array('alias', 'content'),
                'conditions' => array('alias' => $matches[1]),
                'limit' => 25, # prevent flooding and stupidity
            ));
            if (!empty($res)) {
                for ($i = 0; $i < $n; $i++) {
                    $key = $matches[0][$i];
                    $alias = $matches[1][$i];
                    $page[$this->alias]['content'] = str_replace($key, isset($res[$alias]) ? $res[$alias] : '', $page[$this->alias]['content']);
                }
            }
        }
    }

    private function prepareAlias()
    {
        if ($this->valueEmpty('alias')) {
            $this->set('alias', Inflector::slug($this->value('title')));
        }
    }

    private function prepareContent()
    {
        if (!$this->valueEmpty('content')) {
            $this->set('content_length', strlen($this->value('content')));
            $this->set('content_numwords', WikiUtil::str_word_count_utf8($this->value('content')));
        }
    }

    private function checkDuplicatedAlias()
    {
        $n = $this->find('count', array(
            'conditions' => array(
                'alias' => $this->value('alias'),
                'id !=' => $this->id,
            ),
        ));
        if ($n) {
            $this->invalidate('alias', __('The alias %s is already in use, please use another', $this->value('alias')));
        }
    }

    private function renameAlias($old_alias, $new_alias)
    {
        if ($old_alias !== $this->value('alias')) {
            $this->WikiMenu->updateAll(array('page_alias' => $new_alias), array('page_alias' => $old_alias));
        }
    }

}
