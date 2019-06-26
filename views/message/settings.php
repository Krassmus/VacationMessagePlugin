<form action="<?= PluginEngine::getLink($plugin, array(), "message/save") ?>"
      method="post"
      class="default">

    <fieldset>
        <legend><?= _("Abwesenheitsnachricht konfigurieren") ?></legend>

        <label>
            <?= _("Abwesenheit startet") ?>
            <input type="text"
                   name="data[start]"
                   class="has-datetime-picker"
                   value="<?= $vacationmessage['start'] ? date("d.m.Y H:i", $vacationmessage['start']) : "" ?>">
        </label>

        <label>
            <?= _("Abwesenheit endet") ?>
            <input type="text"
                   name="data[end]"
                   class="has-datetime-picker"
                   value="<?= $vacationmessage['end'] ? date("d.m.Y H:i", $vacationmessage['end']) : "" ?>">
        </label>

        <label>
            <?= _("Nachricht") ?>
            <textarea name="data[message]" class="add_toolbar"><?= htmlReady($vacationmessage['message']) ?></textarea>
        </label>

    </fieldset>

    <div data-dialog-button>
        <?= \Studip\Button::create(_("Speichern")) ?>
    </div>
</form>