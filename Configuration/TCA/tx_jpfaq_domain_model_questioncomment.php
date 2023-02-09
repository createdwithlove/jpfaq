<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xlf:tx_jpfaq_domain_model_questioncomment',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'default_sortby' => 'crdate DESC',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,email,comment,finfo,question',
        'typeicon_classes' => [
            'default' => 'tx_jpfaq_domain_model_questioncomment'
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'name, email, comment, question, ip, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_jpfaq_domain_model_questioncomment',
                'foreign_table_where' => 'AND {#tx_jpfaq_domain_model_questioncomment}.{#pid}=###CURRENT_PID### AND {#tx_jpfaq_domain_model_questioncomment}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xlf:tx_jpfaq_domain_model_questioncomment.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'email' => [
            'exclude' => true,
            'label' => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xlf:tx_jpfaq_domain_model_questioncomment.email',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'email, trim'
            ],
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xlf:tx_jpfaq_domain_model_questioncomment.comment',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'required' => true
            ]
        ],
        'finfo' => [
            'exclude' => true,
            'label' => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xlf:tx_jpfaq_domain_model_questioncomment.finfo',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'question' => [
            'exclude' => true,
            'label' => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xlf:tx_jpfaq_domain_model_questioncomment.question',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_jpfaq_domain_model_question',
                'foreign_field' => 'question',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'crdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.creationDate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0
            ],
        ],
        'ip' => [
            'exclude' => true,
            'label' => 'LLL:EXT:jpfaq/Resources/Private/Language/locallang_db.xlf:tx_jpfaq_domain_model_categorycomment.ip',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
    ],
];
