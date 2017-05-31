<?php

return array(
    'guest'         => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'Гость',
        'bizRule'     => null,
        'data'        => null
    ),
    'user'          => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'Пользователь',
        'children'    => array(
            'guest', // унаследуемся от гостя
        ),
        'bizRule'     => null,
        'data'        => null
    ),
    'administrator' => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'Администратор',
        'children'    => array(
            'user', // позволим админу всё, что позволено пользователю
        ),
        'bizRule'     => null,
        'data'        => null
    ),
    'developer'     => array(
        'type'        => CAuthItem::TYPE_ROLE,
        'description' => 'Разработчик',
        'children'    => array(
            'administrator'
        ),
        'bizRule'     => null,
        'data'        => null
    )
);
