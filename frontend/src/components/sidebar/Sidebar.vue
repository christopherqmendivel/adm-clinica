<template>
  <aside class="sidebar">
    <div class="logo">
      <a href="/">
        <img
          src="@/assets/img/logos/logo.webp"
          alt="Chris"
          @click="redirectToHome"
          class="logo w-100"
        />
      </a>
      <h1 class="title">Dashboard</h1>
    </div>
    <nav class="sidebar-nav">
      <ul>
        <li>
          <router-link to="/clinicas">Clínicas</router-link>
        </li>
        <li>
          <router-link to="/empleados">Empleados</router-link>
        </li>
      </ul>
    </nav>
  </aside>
</template>

<script>
export default {
  name: "SideBarMenu",
};
</script>

<style scoped>
.sidebar {
  position: fixed;
  width: 250px;
  height: 100%;
  background-color: var(--grayBG);
}

.logo {
  padding: 20px;
  text-align: center;
  font-size: 1.5rem;
  color: var(--white);
}

.logo .title {
  position: relative;
}

.logo .title::after {
  content: "";
  height: 1rem;
  width: 100%;
  background-color: var(--green);
  display: block;
  margin: -1.4rem 0 0 0;
}

.sidebar-nav {
  padding: 20px;
}

.sidebar-nav ul {
  list-style-type: none;
  padding: 0;
}

.sidebar-nav ul li {
  margin-bottom: 10px;
}

.sidebar-nav ul li a {
  display: block;
  color: var(--white);
  text-decoration: none;
  padding: 10px;
}

.sidebar-nav ul li a:hover {
  background-color: var(--hoverColor);
}
</style>
