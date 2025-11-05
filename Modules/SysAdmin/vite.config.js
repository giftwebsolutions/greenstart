import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    build: {
        outDir: '../../public/build-sysadmin/',
        emptyOutDir: true,
        manifest: true,
        chunkSizeWarningLimit: 1600,
        sourcemap: false,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-sysadmin',
            input: [
                __dirname + '/resources/assets/scss/style.scss',
                __dirname + '/resources/assets/js/app.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jQuery',
            jQuery: 'jquery',
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        },
    },
    rollupOptions: {
        external: [],
    }
});
// Scen all resources for assets file. Return array
//function getFilePaths(dir) {
//    const filePaths = [];
//
//    function walkDirectory(currentPath) {
//        const files = readdirSync(currentPath);
//        for (const file of files) {
//            const filePath = join(currentPath, file);
//            const stats = statSync(filePath);
//            if (stats.isFile() && !file.startsWith('.')) {
//                const relativePath = 'Modules/SysAdmin/'+relative(__dirname, filePath);
//                filePaths.push(relativePath);
//            } else if (stats.isDirectory()) {
//                walkDirectory(filePath);
//            }
//        }
//    }
//
//    walkDirectory(dir);
//    return filePaths;
//}

//const __filename = fileURLToPath(import.meta.url);
//const __dirname = dirname(__filename);

//const assetsDir = join(__dirname, 'resources/assets');
//export const paths = getFilePaths(assetsDir);


//export const paths = [
//    'Modules/SysAdmin/resources/assets/sass/app.scss',
//    'Modules/SysAdmin/resources/assets/js/app.js',
//];
