<?php if (!empty(getSession('request_messages'))) : ?>
  <div class="floating-messages">
  <?php if (getSession('request_messages')->succeeded) : ?>
    <div class="message succeed">
      <?php bind(getSession('request_messages')->success) ?>
    </div>
  <?php endif ?>
  
  <?php if (count(getSession('request_messages')->warnings) > 0) : ?>
    <?php foreach (getSession('request_messages')->warnings as $message) : ?>
      <div class="message warning">
        <?php bind($message) ?>
      </div>
    <?php endforeach ?>
  <?php endif ?>
  
  <?php if (count(getSession('request_messages')->errors) > 0) : ?>
    <?php foreach (getSession('request_messages')->errors as $message) : ?>
      <div class="message error">
        <?php bind($message) ?>
      </div>
    <?php endforeach ?>
  <?php endif ?>
  </div>
<?php endif ?>
<?php setSession('request_messages', null); ?>