<template>
  <div>
    <ul>
      <li v-for="notification in notifications" :key="notification.id">
        Новая статья: {{ notification.title }} ({{ notification.created_at }})
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      notifications: [],
    };
  },
  mounted() {
  Echo.channel('articles')
    .listen('ArticleCreated', (event) => {
      console.log('Received event:', event);
      this.notifications.push(event);
    });
},

};
</script>

<style scoped>
ul {
  list-style: none;
  padding: 0;
}
li {
  margin: 5px 0;
  padding: 10px;
  background-color: #f4f4f4;
  border-radius: 5px;
}
</style>
