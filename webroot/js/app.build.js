({
	appDir: "../",
	baseUrl: "scripts/",
	dir: "../scripts-build",
	//Comment out the optimize line if you want
	//the code minified by UglifyJS
	// optimize: "none",
	paths: {
		"jquery": "empty:"
	},
	//Optimize the application files. jQuery is not
	//included since it is already in require-jquery.js
	modules: [
	{
		name: "main"
	}
	]
})
