<?php

namespace App\Support\Installer;

use RuntimeException;

class EnvironmentWriter
{
    public function write(array $values): void
    {
        $path = base_path('.env');

        if (! is_file($path)) {
            $example = base_path('.env.example');
            if (! is_file($example) || ! copy($example, $path)) {
                throw new RuntimeException('Unable to create the .env file.');
            }
        }

        if (! is_writable($path)) {
            throw new RuntimeException('The .env file is not writable.');
        }

        $contents = (string) file_get_contents($path);

        foreach ($values as $key => $value) {
            $line = $key.'='.$this->encode((string) $value);
            $pattern = '/^[ \t]*'.preg_quote($key, '/').'[ \t]*=.*$/m';

            if (preg_match($pattern, $contents)) {
                $contents = (string) preg_replace($pattern, $line, $contents, 1);
            } else {
                $contents = rtrim($contents).PHP_EOL.$line.PHP_EOL;
            }
        }

        if (file_put_contents($path, $contents, LOCK_EX) === false) {
            throw new RuntimeException('Unable to update the .env file.');
        }
    }

    private function encode(string $value): string
    {
        if ($value === '' || preg_match('/[\s#="\']/u', $value)) {
            return '"'.str_replace(['\\', '"', "\n", "\r"], ['\\\\', '\\"', '\\n', ''], $value).'"';
        }

        return $value;
    }
}
