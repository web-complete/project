<?php

/** @var \WebComplete\mvc\view\View $this */
/** @var array $userState */
/** @var array $navigation */
/** @var string $routesJson */

?>

<div id="app">
    <vue-header></vue-header>
    <div class="page-wrapper">
        <vue-navigation></vue-navigation>
        <router-view></router-view>
    </div>
    <vue-footer></vue-footer>
    <vue-topprogress ref="topProgress" color="#F1A800"></vue-topprogress>
    <v-dialog></v-dialog>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        store.state.navigation.nav = <?=\json_encode($navigation) ?>;
        store.state.user = <?=\json_encode($userState) ?>;
        VueApp.router = new VueRouter({routes: <?=$routesJson ?>});
        window.bus = new Vue();
        Vue.use(Toasted);
        Vue.use(window["vue-js-modal"].default, { dialog: true });
        new Vue(VueApp);
    });
</script>