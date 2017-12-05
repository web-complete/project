<?php

/** @var \WebComplete\mvc\view\View $this */
/** @var array $userState */
/** @var array $navigation */

?>

<div id="app">
    <vue-header></vue-header>
    <div class="page-wrapper">
        <vue-navigation></vue-navigation>
        <router-view></router-view>
    </div>
    <vue-footer></vue-footer>
    <div id="to-top"><i class="ion-arrow-up-b"></i></div>
    <div id="message"></div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        _.extend(window.modules.navigation.state.nav, <?=\json_encode($navigation) ?>);
        _.extend(window.modules.user.state, <?=\json_encode($userState) ?>);
        VueApp.router = new VueRouter({routes: routes});
        new Vue(VueApp);
    });
</script>