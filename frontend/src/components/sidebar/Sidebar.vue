<template>
    <aside class="sidebar">
      <div class="logo">
        <h1>Logo</h1>
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
    name: 'SideBarMenu',
  };
  </script>
  
  <style scoped>
  .sidebar {
    width: 250px;
    height: 100%;
    background-color: #333;
    color: #fff;
  }
  
  .logo {
    padding: 20px;
    text-align: center;
    font-size: 1.5rem;
    color: #fff;
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
    color: #fff;
    text-decoration: none;
    padding: 10px;
  }
  
  .sidebar-nav ul li a:hover {
    background-color: #555;
  }
  </style>
  