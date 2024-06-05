<template>
    <div style="top:0;">
        <div class="flex-shrink-0 p-3 bg-body-tertiary shadow-sm"
            style="width: 280px; position: fixed;  z-index: 99; height: 100%; ">
            <!-- <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                <svg class="bi me-2" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-5 fw-semibold">Collapsible</span>
            </a> -->
            <ul class="list-unstyled ps-0 ">
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                        data-bs-target="#home-collapse" aria-expanded="false">
                        Home
                    </button>
                    <div class="collapse" id="home-collapse" style="">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-4">
                            <li><a href="#" class="link-dark rounded text-decoration-none">Overview</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Updates</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Reports</a></li>
                        </ul>
                    </div>
                </li>
                
                <li class="border-top my-3"></li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse"
                        data-bs-target="#account-collapse" aria-expanded="false">
                        Account
                    </button>
                    <div class="collapse" id="account-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small ms-4">
                            <li><a href="#" class="link-dark rounded text-decoration-none">New...</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Profile</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Settings</a></li>
                            <li><a href="#" class="link-dark rounded text-decoration-none">Sign out</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>

</script>

<style lang="scss" scoped></style>