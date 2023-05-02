<template>
  {{ links }}
    <div>
      <component
        :is="link.url ? 'Link' : 'span'"
        v-for="link in links"
        :class="link.active ? 'red white--text font-bold' : ''"
        :key="link.label"
        v-html="link.label"
        preserve-scroll
        preserve-state
        :href="link.url"
        class="
          py-2
          px-3
          ml-0
          mt-4
          leading-tight
          text-gray-500
          bg-white
          rounded-md
          border border-gray-300
          hover:bg-gray-100 hover:text-gray-700
          dark:bg-gray-800
          dark:border-gray-700
          dark:text-gray-400
          dark:hover:bg-gray-700
          dark:hover:text-white
        "
        ></component
      >
    </div>
  </template>
  
  <script>
  export default {
    props: ["links"],
  };
  </script>
  
  <style>
  </style>