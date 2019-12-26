<template>
  <div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  data: () => ({
    drawer: null,
    items: [
      {
        icon: "home",
        title: "Inicio",
        link: "/home"
      },
      {
        icon: "home",
        title: "Hello",
        link: "/hello"
      },
      {
        icon: "people",
        title: "Usuarios",
        link: ""
      }
    ]
  }),
  methods: {
    goTo(link) {
      this.$router.push(link);
    }
  }
};
</script>
