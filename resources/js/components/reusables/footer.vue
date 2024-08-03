<template>
    <div>
        <div class="flex flex-col w-screen">
            <!-- Sticky goto top button  -->
            <div class="fixed inset-x-0 p-4 mr-0 text-right lg:mr-10 bottom-2" v-if="canGoToTop">
                <button class="p-4 bg-white rounded-lg shadow-lg group" @click="toTop">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-4 h-5 -mt-3 scale-0 opacity-0 fill-current group-hover:opacity-100 text-secondary group-hover:scale-100" viewBox="0 0 330 330"><path d="M325.606,229.393l-150.004-150C172.79,76.58,168.974,75,164.996,75c-3.979,0-7.794,1.581-10.607,4.394 l-149.996,150c-5.858,5.858-5.858,15.355,0,21.213c5.857,5.857,15.355,5.858,21.213,0l139.39-139.393l139.397,139.393 C307.322,253.536,311.161,255,315,255c3.839,0,7.678-1.464,10.607-4.394C331.464,244.748,331.464,235.251,325.606,229.393z"/></svg>
                    
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-4 h-5 -my-3 opacity-0 fill-current group-hover:opacity-100 text-secondary" viewBox="0 0 330 330"><path d="M325.606,229.393l-150.004-150C172.79,76.58,168.974,75,164.996,75c-3.979,0-7.794,1.581-10.607,4.394 l-149.996,150c-5.858,5.858-5.858,15.355,0,21.213c5.857,5.857,15.355,5.858,21.213,0l139.39-139.393l139.397,139.393 C307.322,253.536,311.161,255,315,255c3.839,0,7.678-1.464,10.607-4.394C331.464,244.748,331.464,235.251,325.606,229.393z"/></svg>

                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-4 h-5 fill-current group-hover:-mb-3 text-secondary " viewBox="0 0 330 330"><path d="M325.606,229.393l-150.004-150C172.79,76.58,168.974,75,164.996,75c-3.979,0-7.794,1.581-10.607,4.394 l-149.996,150c-5.858,5.858-5.858,15.355,0,21.213c5.857,5.857,15.355,5.858,21.213,0l139.39-139.393l139.397,139.393 C307.322,253.536,311.161,255,315,255c3.839,0,7.678-1.464,10.607-4.394C331.464,244.748,331.464,235.251,325.606,229.393z"/></svg>
                </button>
            </div>
        </div>
        <div class="flex flex-col px-16 py-4 bg-white md:flex-row">
            <div class="w-3/5 mt-6">
                <img :src="logo_src" class="z-10 self-center h-12 lg:h-10"/>
            </div>
            <div class="w-full mt-4">    
                <span class="mt-10 font-bold md:mt-5 lg:mt-5 lg:text-lg text-l"> {{ $Lang_get('guest.accessibility')}} </span>
                <ul class="mt-3 leading-loose">
                    <li>
                        <router-link to="/new-request" exact><span class="py-1 text-xs lg:text-sm">{{ $Lang_get('guest.how_to_create_new_request')}}</span></router-link>
                    </li>
                    <li>
                        <router-link to="/inscription" exact><span class="py-1 text-xs lg:text-sm">{{ $Lang_get('auth.register') }}</span></router-link>
                    </li>
                    <li>
                        <router-link to="/track-my-request" exact><span class="py-1 text-xs lg:text-sm">
                        {{ $Lang_get('guest.track_my_request')}}
                        </span>
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class="w-full mt-4">
                <span class="mt-10 font-bold md:mt-5 lg:mt-5 lg:text-lg text-l"> {{ $Lang_get('guest.about_us')}} </span>
                <ul class="mt-3 leading-loose">
                    <li>
                        <router-link to="/first-link" exact><span class="py-1 text-xs lg:text-sm">{{ $Lang_get('guest.first_link')}}</span></router-link>
                    </li>
                    <li>
                        <router-link to="/second-link" exact><span class="py-1 text-xs lg:text-sm">{{ $Lang_get('guest.second_link') }}</span></router-link>
                    </li>
                    <li>
                        <router-link to="/third-link" exact><span class="py-1 text-xs lg:text-sm">
                        {{ $Lang_get('guest.third_link')}}
                        </span>
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class="w-full mt-4">
                <span class="mt-10 font-bold md:mt-5 lg:mt-5 lg:text-lg text-l"> {{ $Lang_get('guest.contact_us')}} </span>
                <div class="pb-5 mt-5 lg:flex lg:flex-row">
                    <div class="w-full lg:w-1/2">
                        <span class="py-1 text-sm font-bold lg:text-sm">{{ $Lang_get('guest.address')}} : </span>
                    </div>
                    <div class="w-full py-1 text-xs lg:text-sm">{{address}}</div>
                </div>
                <div class="pb-5 lg:flex lg:flex-row">
                    <div class="w-full lg:w-1/2">
                        <span class="py-1 text-sm font-bold lg:text-sm">{{ $Lang_get('guest.telephone')}} : </span>
                    </div>
                    <div class="w-full py-1 text-xs lg:text-sm">{{telephone}}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    components: {
	},
    data() {
        return {
            logo_src: '/assets/img/logo' + process.env.MIX_CLIENT_CODE + '.svg',
            address: '800, boulevard De Maisonneuve Est, Montréal (Québec) H2L 4S8',
            telephone: 'De l’île de Montréal: 311 L’extérieur de l’île de Montréal: 514.872.0311',
            canGoToTop : false,
        };
    },
    mounted() {
        this.handleScroll();
    },
    methods:{
        toTop: function () {
            window.scrollTo({
            top: 0,
            behavior: "smooth"
            });
        },
        handleScroll: function(e) {
            window.onscroll = () => {
                if (document.documentElement.scrollTop === 0) {
                    this.canGoToTop = false;
                }else{
                    this.canGoToTop = true;
                }
            }
        }
    }
}
</script>