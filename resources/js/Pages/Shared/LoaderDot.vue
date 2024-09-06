<template>
    <span class="dot dot1">.</span>
    <span class="dot dot2">.</span>
    <span class="dot dot3">.</span>
</template> 

<style>
.dot1{
    animation: dot1 1000ms ease-in-out 0s infinite;
}
.dot2{
    animation: dot2 1000ms ease-in-out 0s infinite;
}
.dot3{
    animation: dot3 1000ms ease-in-out 0s infinite;
}
@keyframes dot1 {
    0%{opacity: 0;}
    33%{opacity: 1;}
    66%{opacity: 1;}
    99%{opacity: 1;}
}
@keyframes dot2 {
    0%{opacity: 0;}
    33%{opacity: 0;}
    66%{opacity: 1;}
    99%{opacity: 1;}
}
@keyframes dot3 {
    0%{opacity: 0;}
    33%{opacity: 0;}
    66%{opacity: 0;}
    99%{opacity: 1;}
}
</style>