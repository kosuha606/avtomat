<?php

namespace Avtomat\Factory;

class BlackBoxFactory
{
    private function generateId()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
            mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * @param type $boxName
     * @return \BlackBox
     * @throws NotFoundBlackBoxException
     */
    public function create($boxName)
    {
        if (class_exists($boxName.'Box')) {
            $objectClass = $boxName.'Box';
            $object = new $objectClass();
            if ($object instanceof BlackBox) {
                $object->setId($this->generateId());

                return $object;
            }
        }

        throw new NotFoundBlackBoxException(sprintf('Попытка создвать BlackBox c не известным именем %s', $boxName));
    }
}