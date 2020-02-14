<?php

function isLoggedIn() {
  return getSession('user') ? true : false;
}
