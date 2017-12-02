Vue.component('VuePageLogin', {
    store: store,

    // language=Vue
    template: '<div class="page-wrapper">\n    <div class="loginWrapper">\n        <div id="loginBlock" class="login" :class="{hasErrors: $store.state.user.loginError}">\n            <form @submit.prevent="submit" action="" method="post">\n                <div id="logo">\n                    <svg width="201px" height="36px" viewBox="27 20 201 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\n                        <defs></defs>\n                        <g id="logo" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(27.000000, 20.000000)">\n                            <path d="M0.0625403031,10.5479297 C0.0887086889,9.43792969 0.236749265,8.71792969 1.70564237,7.88771159 C3.17453548,7.05749348 13.6036655,0.9306978 14.1822294,0.578964844 C14.9224322,0.128964844 16.0327366,0.0239648437 16.8913719,0.548964844 C17.7500072,1.07396484 24.5279354,5.05938308 24.5279354,5.05938308 L0.0625403031,19.3652357 C0.0625403031,19.3652357 0.0363719172,11.6579297 0.0625403031,10.5479297 Z" id="Path-1" fill="#F6A623"></path>\n                            <path d="M0.127092797,21.9781768 C0.127092797,21.9781768 34.5530893,1.87886901 35.9740116,1.03839935 C37.3949339,0.197929688 39.0825964,0.287929688 40.0647587,0.900519162 C41.046921,1.51310864 46.9922032,4.99405955 46.9922032,4.99405955 L4.58121486,29.8170002 L0.0625403031,27.3347061 L0.127092797,21.9781768 Z" id="Path-2" fill="#F6A623"></path>\n                            <path d="M13.8564823,35.3579297 C11.4387959,33.9114211 6.90510463,31.1887942 6.90510463,31.1887942 L49.3806454,6.30053011 L53.8347675,8.97879475 L53.7056625,14.1393535 C53.7056625,14.1393535 20.532345,33.680769 18.2899139,34.9843494 C16.0474828,36.2879297 14.3866931,35.6751563 13.8564823,35.3579297 Z" id="Path-3" fill="#D78500"></path>\n                            <path d="M36.4867944,35.3924231 C35.4306144,34.7669165 29.4984774,31.2541178 29.4984774,31.2541178 L53.8347675,16.8176181 C53.8347675,16.8176181 53.829011,23.2077519 53.7838122,25.0678408 C53.7386135,26.9279297 52.9095862,27.7379297 51.8546909,28.3954262 C51.0585395,28.8916525 43.6938152,33.2066463 40.1288848,35.2935495 C38.970306,35.9717792 37.5429744,36.0179297 36.4867944,35.3924231 Z" id="Path-4" fill="#BD7500"></path>\n                            <path d="M90.6,12 L86.6,26 L84.3,26 L80.92,15.88 L77.6,26 L75.28,26 L71.1,12 L73.86,12 L76.68,21.98 L79.8,12 L82.24,12 L85.44,22 L88.24,12 L90.6,12 Z M97.72,23.48 L98.38,25.1 C97.48,25.86 96.2,26.22 94.94,26.22 C92.04,26.22 90.1,24.34 90.1,21.5 C90.1,18.88 91.9,16.78 94.86,16.78 C97.18,16.78 99.12,18.44 99.12,20.96 C99.12,21.52 99.08,21.86 98.98,22.2 L92.48,22.2 C92.68,23.56 93.76,24.3 95.18,24.3 C96.28,24.3 97.2,23.9 97.72,23.48 Z M94.76,18.7 C93.38,18.7 92.64,19.48 92.4,20.66 L96.82,20.66 C96.84,19.56 96.08,18.7 94.76,18.7 Z M100.98,25.22 L100.98,12 L103.28,12 L103.28,17.56 C103.84,17.12 104.7,16.78 105.66,16.78 C108.34,16.78 109.94,18.7 109.94,21.36 C109.94,24.32 107.96,26.22 104.8,26.22 C103.32,26.22 101.8,25.74 100.98,25.22 Z M105.12,18.94 C104.32,18.94 103.66,19.36 103.28,19.8 L103.28,23.62 C103.78,23.94 104.28,24.08 104.92,24.08 C106.36,24.08 107.48,23.14 107.48,21.52 C107.48,19.8 106.42,18.94 105.12,18.94 Z" id="Web" fill="#000000"></path>\n                            <path d="M128.84,23.36 C127.88,24.14 126.6,24.6 125.26,24.6 C122.02,24.6 119.8,22.34 119.8,19 C119.8,15.68 121.96,13.4 125,13.4 C126.46,13.4 127.54,13.76 128.46,14.44 L129.24,13.16 C128.24,12.3 126.78,11.8 124.98,11.8 C120.6,11.8 118,14.98 118,19 C118,23.36 120.9,26.2 125.1,26.2 C126.84,26.2 128.58,25.6 129.52,24.64 L128.84,23.36 Z M130.42,21.5 C130.42,18.8 132.34,16.8 135.22,16.8 C138.1,16.8 140.02,18.8 140.02,21.5 C140.02,24.2 138.1,26.2 135.22,26.2 C132.34,26.2 130.42,24.2 130.42,21.5 Z M132.12,21.5 C132.12,23.38 133.42,24.7 135.22,24.7 C137.02,24.7 138.32,23.42 138.32,21.5 C138.32,19.62 137.02,18.3 135.22,18.3 C133.46,18.3 132.12,19.6 132.12,21.5 Z M155.68,20.1 C155.68,17.64 154.44,16.84 152.78,16.84 C151.42,16.84 150.26,17.48 149.62,18.4 C149.28,17.46 148.3,16.84 146.9,16.84 C145.74,16.84 144.58,17.36 143.92,18.14 L143.92,17 L142.32,17 L142.32,26 L143.92,26 L143.92,19.56 C144.38,18.9 145.24,18.34 146.28,18.34 C147.54,18.34 148.2,19.1 148.2,20.2 L148.2,26 L149.8,26 L149.8,20.28 C149.8,20.08 149.8,19.8 149.78,19.64 C150.2,18.9 151.06,18.34 152.14,18.34 C153.44,18.34 154.08,19.06 154.08,20.54 L154.08,26 L155.68,26 L155.68,20.1 Z M158.38,30 L158.38,17 L159.98,17 L159.98,18.06 C160.6,17.34 161.8,16.8 163.04,16.8 C165.6,16.8 167.2,18.7 167.2,21.36 C167.2,24.1 165.34,26.2 162.52,26.2 C161.56,26.2 160.62,26 159.98,25.58 L159.98,30 L158.38,30 Z M162.58,18.3 C161.52,18.3 160.54,18.84 159.98,19.54 L159.98,24 C160.78,24.54 161.52,24.7 162.38,24.7 C164.3,24.7 165.5,23.32 165.5,21.42 C165.5,19.6 164.44,18.3 162.58,18.3 Z M169.5,23.6 C169.5,25.34 170.18,26.16 171.54,26.16 C172.48,26.16 173.18,25.86 173.66,25.48 L173.3,24.26 C173,24.46 172.6,24.66 172.16,24.66 C171.4,24.66 171.1,24.1 171.1,22.88 L171.1,12 L169.5,12 L169.5,23.6 Z M182.4,23.76 L182.9,25.02 C182.02,25.82 180.72,26.2 179.52,26.2 C176.6,26.2 174.7,24.34 174.7,21.5 C174.7,18.88 176.38,16.8 179.34,16.8 C181.66,16.8 183.52,18.44 183.52,20.92 C183.52,21.36 183.48,21.72 183.42,22 L176.5,22 C176.64,23.7 177.88,24.7 179.64,24.7 C180.8,24.7 181.82,24.3 182.4,23.76 Z M179.26,18.3 C177.62,18.3 176.58,19.32 176.4,20.7 L181.86,20.7 C181.78,19.22 180.82,18.3 179.26,18.3 Z M185.5,22.58 C185.5,24.88 186.3,26.16 188.32,26.16 C189.32,26.16 190.14,25.8 190.62,25.4 L190.12,24.16 C189.8,24.4 189.32,24.66 188.7,24.66 C187.56,24.66 187.1,23.84 187.1,22.42 L187.1,18.5 L190.4,18.5 L190.4,17 L187.1,17 L187.1,14.5 L185.5,14.5 L185.5,22.58 Z M199.5,23.76 L200,25.02 C199.12,25.82 197.82,26.2 196.62,26.2 C193.7,26.2 191.8,24.34 191.8,21.5 C191.8,18.88 193.48,16.8 196.44,16.8 C198.76,16.8 200.62,18.44 200.62,20.92 C200.62,21.36 200.58,21.72 200.52,22 L193.6,22 C193.74,23.7 194.98,24.7 196.74,24.7 C197.9,24.7 198.92,24.3 199.5,23.76 Z M196.36,18.3 C194.72,18.3 193.68,19.32 193.5,20.7 L198.96,20.7 C198.88,19.22 197.92,18.3 196.36,18.3 Z" id="Complete" fill="#000000"></path>\n                        </g>\n                    </svg>\n                </div>\n\n                <input v-model="login" autofocus class="login__input" type="text" name="login" placeholder="Логин" value="" />\n                <input v-model="password" class="login__input" type="password" name="password" placeholder="Пароль" value="" />\n                <button class="login__button" type="submit">Войти</button>\n                <div class="clear"></div>\n            </form>\n        </div>\n    </div>\n</div>\n',

    data: function(){
        return {
            login: '',
            password: ''
        }
    },

    // TODO watch for token? then redirect

    methods: {
        submit: function(){
            var self = this;
            self.$store.dispatch('login', {
                login: this.login,
                password: this.password,
                redirect: true
            });
        }
    }
});