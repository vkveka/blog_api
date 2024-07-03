<template>
    <div class="sticky-top shadow">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <img src="../../../public/images/logo2.png" alt="logo blog_api" width="100px" class="mx-5 my-1">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Recherche" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Rechercher</button>
                    </form>
                    <div class="btn-group dropstart ms-5 me-3" style="cursor: pointer;">
                        <div v-if="userStore.user">
                            <img :src="getUserImage(userStore.user.image)" data-bs-toggle="dropdown"
                                aria-expanded="false" class="dropdown-toggle img_user" alt="image user non connecté"
                                width="40px">
                            <!-- <img src="../../../public/images/logo.png" data-bs-toggle="dropdown" aria-expanded="false"
                                class="dropdown-toggle" alt="image user non connecté" width="40px"> -->
                            <ul class="dropdown-menu">
                                <li><router-link :user="user" class="dropdown-item"
                                        :to="{ name: 'user', params: { id: userStore.user.id } }">Mon
                                        Compte</router-link></li>
                                <li><router-link class="dropdown-item" to="/logout"
                                        @click="logOut">Deconnexion</router-link></li>
                                <!-- <li><router-link class="dropdown-item" to="/login">Connexion</router-link></li> -->

                            </ul>
                        </div>
                        <div v-else>
                            <img src="../../../public/images/user.png" data-bs-toggle="dropdown" aria-expanded="false"
                                class="dropdown-toggle" alt="image user non connecté" width="40px">
                            <ul class="dropdown-menu">
                                <li><router-link class="dropdown-item" to="/login">Connexion</router-link></li>
                                <li><router-link class="dropdown-item" to="/register">Inscription</router-link></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/userStore';
const router = useRouter();
const userStore = useUserStore();

const logOut = () => {
    userStore.removeUser()

    axios.post('/api/logout')
        .then(response => {
            console.log(response)
            router.push('/')
        })
        .catch(error => {
            console.error('Erreur lors de la déconnexion:', error);
        });
};

const getUserImage = (imageName) => {
    return imageName ? `http://[::1]:5173/public/images/${imageName}` : '../../../public/images/logo.png';
};
</script>

<style scoped>
.img_user {
    border-radius: 10vh;
}
</style>