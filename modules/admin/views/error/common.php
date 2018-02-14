<?php

/** @var $status */
if (!$status) {
    $status = 'Error';
}
?>
<style>
    .page-error {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #ddd;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .page-error ._status {
        position: relative;
        top: -5%;
        font-weight: bold;
        font-size: 20rem;
        color: #fff;
        text-shadow: 1px 1px 1px #aaa;
        transition: all 0.7s ease-out;
        transform: scale(1.1);
        opacity: 0;
    }
    .page-error ._status._show {
        top: 0;
        opacity: 1;
        transform: scale(1);
    }
</style>

<div class="page-error">
    <div class="_status"><?=$status ?></div>
</div>

<script type="text/javascript">
    setTimeout(function(){
        document.querySelectorAll('._status')[0].className = '_status _show';
    }, 0);
</script>