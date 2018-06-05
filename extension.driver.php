<?php

class Extension_UniqueCheckboxField extends Extension
{

    public function install()
    {
        return Symphony::Database()
            ->create('tbl_fields_uniquecheckbox')
            ->ifNotExists()
            ->charset('utf8')
            ->collate('utf8_unicode_ci')
            ->fields([
                'id' => [
                    'type' => 'int(11)',
                    'auto' => true,
                ],
                'field_id' => 'int(11)',
                'default_state' => [
                    'type' => 'enum',
                    'values' => ['on', 'off'],
                    'default' => 'on',
                ],
                'unique_entries' => [
                    'type' => 'int(11)',
                    'default' => 1,
                ],
                'unique_steal' => [
                    'type' => 'enum',
                    'values' => ['on', 'off'],
                    'default' => 'on',
                ],
            ])
            ->keys([
                'id' => 'primary',
                'field_id' => 'key',
            ])
            ->execute()
            ->success();
    }

    public function uninstall()
    {
        return Symphony::Database()
            ->drop('tbl_fields_uniquecheckbox')
            ->ifExists()
            ->execute()
            ->success();
        }

    public function update($previousVersion = false)
    {
        if (version_compare($previousVersion, '1.3', '<'))
        {
            try{
                Symphony::Database()
                    ->alter('tbl_fields_uniquecheckbox')
                    ->drop('description')
                    ->execute()
                    ->execute();
            }
            catch(Exception $e){
                // Discard
            }
        }
    }
}
