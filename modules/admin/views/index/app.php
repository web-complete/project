<?php

use modules\admin\controllers\AbstractController;

/** @var \WebComplete\mvc\view\View $this */
/** @var array $settingsState */
/** @var array $userState */
/** @var array $langState */
/** @var array $navigation */
/** @var string $routesJson */

/** @var AbstractController $controller */
$controller = $this->getController();
$settings = $controller->settings;
$themeColor1 = $settings->get('theme_color1', '#F1A800');

?>

<div id="app">
    <vue-header></vue-header>
    <div class="page-wrapper">
        <vue-navigation></vue-navigation>
        <transition name="page">
            <router-view></router-view>
        </transition>
    </div>
    <vue-footer></vue-footer>
    <vue-topprogress ref="topProgress" color="<?=$themeColor1 ?>"></vue-topprogress>
    <v-dialog></v-dialog>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        store.state.navigation.nav = <?=\json_encode($navigation) ?>;
        store.state.user = <?=\json_encode($userState) ?>;
        store.state.settings = <?=\json_encode($settingsState) ?>;
        store.state.lang = <?=\json_encode($langState) ?>;
        VueApp.router = new VueRouter({routes: <?=$routesJson ?>});
        window.bus = new Vue();
        Vue.use(Toasted);
        Vue.use(window["vue-js-modal"].default, { dialog: true });
        new Vue(VueApp);
    });
</script>