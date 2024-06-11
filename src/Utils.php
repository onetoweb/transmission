<?php

namespace Onetoweb\TransMission;

/**
 * Utils
 */
final class Utils
{
    /**
     * @param string $filepath
     * @param array $data
     * 
     * @return bool
     */
    public static function storeLabel(string $filepath, array $results): bool
    {
        if (isset($results['data']['labels']['label_content'])) {
            
            $contents = base64_decode($results['data']['labels']['label_content']);
            
            return file_put_contents($filepath, $contents) !== false;
        }
        
        return false;
    }
}