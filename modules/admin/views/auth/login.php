<?php
/** @var \WebComplete\mvc\view\View $this */
/** @var array $settingsState */
?>

<div id="app">
    <vue-page-login></vue-page-login>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        store.state.settings = <?=\json_encode($settingsState) ?>;
        window.bus = new Vue();
        Vue.use(Toasted);
        new Vue(VueApp);
    });
</script>