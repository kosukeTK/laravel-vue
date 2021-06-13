<template>
  <button @click="helloTrans">大文字化！</button>
</template>

<script>
export default {
  props:{
    message: String
  },

  setup(props, context){

    const helloTrans = () => {
      let tomato = props.message + "トマトジュース"
      context.emit("change-message", tomato);
    //  context.emit("change-message", props.message.toUpperCase());
    };

    return {
      helloTrans
    };
  }
};
</script>
