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
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Recherche" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Rechercher</button>
                    </form>
                    <div class="btn-group dropstart ms-5 me-3" style="cursor: pointer;">
                        <div v-if="checkAuth">
                            <img src="../../../public/images/logo.png" data-bs-toggle="dropdown" aria-expanded="false"
                                class="dropdown-toggle" alt="image user non connecté" width="40px">
                            <ul class="dropdown-menu">
                                <li><router-link class="dropdown-item" to="/">Mon Compte</router-link></li>
                                <li><router-link class="dropdown-item" to="/logout"
                                        @click="logOut">Deconnexion</router-link></li>
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
const checkAuth = () => {
    axios.get('/auth-user', {
        withCredentials: true, // Assurez-vous que les cookies de session sont envoyés
    })
        .then(response => {
            if (response.data.authenticated) {
                currentUser.value = response.data.user;
                isAuthenticated.value = true;
            } else {
                currentUser.value = null;
                isAuthenticated.value = false;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            currentUser.value = null;
            isAuthenticated.value = false;
        });
};

const logOut = () => {
    axios.post('/api/logout', {
        withCredentials: true,
    })
        .then(response => {
            console.log(response)
            window.location.href = response.data.redirect;
        })
        .catch(error => {
            console.error('Erreur lors de la déconnexion:', error);
        });
};


</script>

<style lang="scss" scoped></style>