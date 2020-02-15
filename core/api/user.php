<?php

function getCurrentUser()
{
  return getGlobal('user');
}

function isAdmin()
{
  if (!getCurrentUser()) {
    return false;
  }

  return getCurrentUser()->administrador;
}

function getUserName() {
  if (!getCurrentUser()) return null;
  return getCurrentUser()->nombre;
}

function getUserId() {
  if (!getCurrentUser()) return null;
  return getCurrentUser()->id;
}