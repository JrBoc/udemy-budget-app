<?php

function is_invalid($errors, $name = '')
{
    return $errors->has($name) ? 'is-invalid' : '';
}
