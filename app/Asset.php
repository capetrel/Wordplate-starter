<?php


namespace App;

class Asset
{

    /**
     * @var array
     */
    private $manifest;

    /**
     * @var string
     */
    private $assetsPath;

    public function __construct(string $assetsPath)
    {
        $this->assetsPath = $assetsPath;
    }

    /**
     * @param string $filename
     * @return string|null
     */
    public function getPath(string $filename): ?string
    {
        $info = explode('.', $filename);
        $ext = end($info);
        if ($ext === 'css') {
            return get_stylesheet_directory_uri() . '/assets/css/' .$filename;
        } elseif ($ext === 'js') {
            return get_stylesheet_directory_uri() . '/assets/js/' .$filename;
        } else {
            return 'fichier iconnu';
        }
    }

    /**
     * @param string $filename
     * @return string|null
     */
    public function getManifestPath(string $filename): ?string
    {
        $path = $this->getManifest()[$filename] ?? $filename;
        if (strpos($path, 'http://') !== false) {
            return $path;
        }
        return get_stylesheet_directory_uri() . '/assets/' .$path;
    }

    /**
     * @return mixed
     */
    public function getManifest()
    {
        if (!$this->manifest) {
            $this->manifest = json_decode(file_get_contents($this->assetsPath) . '/mix-manifest.json');
        }
        return $this->manifest;
    }

}
