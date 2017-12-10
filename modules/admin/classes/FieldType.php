<?php

namespace modules\admin\classes;

class FieldType
{

    /**
     * @see FieldHelper.js
     */
    const STRING   = 'string'; // VueFieldString
    const SELECT   = 'select'; // VueFieldSelect
    const CHECKBOX = 'checkbox'; // VueFieldCheckbox
    const TEXTAREA = 'textarea'; // VueFieldTextarea
    const REDACTOR = 'redactor'; // VueFieldRedactor
    const FILE     = 'file'; // VueFieldFile
    const IMAGE    = 'image'; // VueFieldImage
    const TAGS     = 'tags'; // VueFieldTags
}
