<template>
    <main>
        <!-- si la route est différente de / (racine du site) -->
        <!-- on affiche le template du composant concerné par la route -->
        <div v-if="$route.path !== '/'">
            <router-view v-bind:key="$route.fullPath"></router-view>
        </div>
        <div v-else>
            <Navbar />
            <div class="row">
                <Sidebar class="col-3" />
                <ListPosts class="col-9 offset-xl-3 offset-md-4 offset-3" />
            </div>
            <Footer />
        </div>
    </main>
</template>

<script setup>
import ListPosts from './components/ListPosts.vue';
import Sidebar from './components/Sidebar.vue';
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';


</script>

<style scoped></style>