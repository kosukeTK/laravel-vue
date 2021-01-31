<template>
    <button @click="helloTrans">大文字化！</button>
</template>

<script>
export default {
    props:{
        msg: String
    },

    setup(props, context){

        const helloTrans = () => {
            context.emit("change-message", props.msg.toUpperCase());
        };

        return {
            helloTrans
        };
    }
}
</script>
