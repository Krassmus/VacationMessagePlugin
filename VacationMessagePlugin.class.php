<?php

require_once __DIR__."/lib/VacationMessage.php";

class VacationMessagePlugin extends StudIPPlugin implements SystemPlugin
{
    public function __construct()
    {
        parent::__construct();
        if ($GLOBALS['perm']->have_perm("autor")
                && (stripos($_SERVER['REQUEST_URI'], "dispatch.php/messages") !== false)) {
            $vacationmessage = new VacationMessage($GLOBALS['user']->id);
            if ($vacationmessage->isActive()) {
                PageLayout::postInfo(_("Es ist eine Abwesenheitsnachricht aktiv."));
            }
            NotificationCenter::addObserver($this, "addLinkToSidebar", "SidebarWillRender");
            NotificationCenter::addObserver($this, "checkAndSendVacationMessage", "MessageDidSend");
        }
    }

    public function addLinkToSidebar()
    {
        $actions = Sidebar::Get()->getWidget("actions");
        $actions->addLink(
            _("Abwesenheitsnachricht konfigurieren"),
            PluginEngine::getURL($this, array(), "message/settings"),
            Icon::create($this->getPluginURL()."/assets/vacancy-1.svg"),
            array('data-dialog' => 1)
        );
    }

    public function checkAndSendVacationMessage($event, $message_id)
    {
        $message = new Message($message_id);
        foreach ($message->receivers as $message_user) {
            if ($message_user['snd_rec'] === "rec" && ($message_user['user_id'] !== $GLOBALS['user']->id)) {
                $vacationmessage = new VacationMessage($message_user['user_id']);
                if ($vacationmessage->isActive()) {
                    $begin = "Automatische Antwort: ";
                    if (($message['autor_id'] !== "____%system%____")
                            && (substr($message['subject'], 0, strlen($begin)) !== $begin)) {
                        $messaging = new messaging();
                        $messaging->insert_message(
                            $vacationmessage['message'],
                            get_username($GLOBALS['user']->id),
                            $message_user['user_id'],
                            '',
                            '',
                            '',
                            '',
                            $begin . $message['subject'],
                            '',
                            'normal',
                            $tags = array("Abwesenheit")
                        );
                    }
                }
            }
        }
    }
}