<?php

foreach (glob("./app/database/tables/*.php") as $filename) {
    include_once $filename;
}

