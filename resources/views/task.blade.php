<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div id="app">
<!-- <input type="text" v-model="coupon"> -->
    <!-- we bind value of coupon in data with input by using :value -->
    <!-- v-model = :value="data"  @input="data=$event.target.value" -->
<coupon v-model="coupon"></coupon>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="/js/task.js" ></script>
</body>
</html>
