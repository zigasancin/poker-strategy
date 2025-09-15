const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');
const fs = require('fs');

class CopyAssetsToThemePlugin {
	apply(compiler) {
		compiler.hooks.thisCompilation.tap('CopyAssetsToThemePlugin', (compilation) => {
			compilation.hooks.processAssets.tap(
				{
					name: 'CopyAssetsToThemePlugin',
					stage: compiler.webpack.Compilation.PROCESS_ASSETS_STAGE_REPORT,
				},
				(assets) => {
					for (const filename of Object.keys(assets)) {
						if (!filename.startsWith('assets/js/') && !filename.startsWith('assets/css/')) {
							continue;
						}

						const asset = assets[filename];
						const targetPath = path.resolve(compiler.options.context, filename);
						const dir = path.dirname(targetPath);
						fs.mkdirSync(dir, { recursive: true });
						fs.writeFileSync(targetPath, asset.source());
					}
				}
			);
		});
	}
}

module.exports = {
	...defaultConfig,
	output: {
		...defaultConfig.output,
		filename: 'assets/js/[name].js',
		path: path.resolve(__dirname, 'build'),
		publicPath: '/build/',
	},
	plugins: [
		// remove CleanWebpackPlugin so root files never get deleted
		...defaultConfig.plugins.filter(
		(plugin) => {
			const name = plugin.constructor && plugin.constructor.name;
			return name !== 'CleanWebpackPlugin' && name !== 'DependencyExtractionWebpackPlugin';
		}
		),
		new MiniCssExtractPlugin({
			filename: 'assets/css/[name].css',
		}),
		new CopyAssetsToThemePlugin(),
	],
	devServer: {
		static: {
			directory: path.join(__dirname, 'build'),
		},
		hot: true,
		devMiddleware: {
			writeToDisk: true,
		},
	},
};
