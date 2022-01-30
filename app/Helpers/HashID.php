<?php

function HashEncode($id)
{

    return (new \Hashids\Hashids())->encodeHex($id);
}

function HashDecode($key)
{
    return (new \Hashids\Hashids())->decodeHex($key);
}
