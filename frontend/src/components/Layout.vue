<template>
  <div id="layout">
    <Sidebar />
    <div class="main-content">
      <router-view />
    </div>
  </div>
</template>

<script>
import Sidebar from './sidebar/Sidebar.vue';

export default {
  name: "LayoutPage",
  components: {
    Sidebar
  }
};
</script>

<style scoped>
#layout {
  display: flex;
  height: 100vh;
}

.main-content {
  flex: 1;
  padding: 20px;
  margin-left: 250px;
  background-color: var(--bgColor);
  color: var(--white);
}
</style>
