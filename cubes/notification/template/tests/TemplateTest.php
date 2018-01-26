<?php

namespace cubes\notification\template\tests;

use cubes\notification\template\Template;

class TemplateTest extends \AppTestCase
{
    public function testRender()
    {
        $template = new Template();
        $template->html = 'Some content with {{var}}{{not_exists_var}}';
        $result = $template->renderHtml(['var' => 'compiled var', 'not_needed_var' => 'nnv']);
        $this->assertEquals($result, 'Some content with compiled var');

        $template->subject = 'Some content with {{var}}{{not_exists_var}}';
        $result = $template->renderHtml(['var' => 'compiled var', 'not_needed_var' => 'nnv']);
        $this->assertEquals($result, 'Some content with compiled var');
    }
}
