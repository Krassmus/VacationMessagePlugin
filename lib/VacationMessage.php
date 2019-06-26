<?php

class VacationMessage extends SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'vacation_messages';
        parent::configure($config);
    }

    public function isActive()
    {
        return (!$this['start'] || $this['start'] < time())
            && (!$this['end'] || $this['end'] >= time())
            && ($this['start'] || $this['end'])
            && $this['message'];
    }
}