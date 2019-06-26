<?php

class MessageController extends PluginController
{
    public function settings_action()
    {
        Navigation::activateItem("/messaging");
        $this->vacationmessage = new VacationMessage($GLOBALS['user']->id);
    }

    public function save_action()
    {
        if (Request::isPost()) {
            $this->vacationmessage = new VacationMessage($GLOBALS['user']->id);
            $data = Request::getArray("data");
            unset($data['user_id']);
            unset($data['chdate']);
            unset($data['mkdate']);
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $this->vacationmessage->setData($data);
            $this->vacationmessage->store();
            PageLayout::postSuccess(_("Daten wurden gespeichert."));
        }
        $this->redirect(URLHelper::getURL("dispatch.php/messages/overview"));
    }
}