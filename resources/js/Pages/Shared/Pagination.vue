<template>
    <div class="wrapper-pagination">
       <div class="number-of-data text-xs md:text-sm text-gray-500">
          Show {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} entries
       </div>
       <ul class=" flex space-x-3 space-y-4">
          <li class=" mt-4">
            <Link v-if="pagination.current_page !== 1"
                  :href="`${pagination.path}?page=${pagination.current_page - 1}`"> 
                  <box-icon name='chevron-left' size="sm"></box-icon>
            </Link> 
          </li>
          <li class=" mt-4" v-if="pagination.current_page > visiblePagesCount">
            <Link :href="pagination.first_page_url"
                  class=" px-3 py-2 text-sm border rounded-lg text-gray-500"> 
                  1
            </Link> 
            <span>...</span>
          </li>
          <li 
              v-for="page in pageObj.visiblePages"
              class="inline-block"> 
             <Link 
                  :href="`${pagination.path}?page=${page}`" 
                  :class="{'bg-indigo-600 text-white': page === pagination.current_page}"
                  class=" px-3 py-2 text-sm border rounded-lg text-gray-500">{{ page }}</Link>
          </li>
          <li class=" mt-4" v-if="pagination.current_page <= (pagination.last_page - visiblePagesCount) && pageObj.endPage !== pagination.last_page">
            <span>...</span>
            <Link :href="pagination.last_page_url"
                  class=" px-3 py-2 text-sm border rounded-lg text-gray-500"> 
                  {{ pagination.last_page }} 
            </Link> 
          </li>
          <li class=" mt-4">
            <Link v-if="pagination.current_page !== pagination.last_page"
                 :href="`${pagination.path}?page=${pagination.current_page + 1}`"> 
                   <box-icon name='chevron-right' size="sm"></box-icon>
            </Link> 
          </li>
       </ul>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
const prop = defineProps({
    pagination: Object 
}) 
 

const visiblePagesCount = ref(3)
const pageObj = ref({});

onMounted(() => {
  pageObj.value = updatePagination()
})

const updatePagination = () => { 

  let startPage = Math.floor((prop.pagination.current_page - 1) / visiblePagesCount.value) * visiblePagesCount.value + 1;
  let endPage = Math.min(startPage + visiblePagesCount.value - 1, prop.pagination.last_page);

  const visiblePages = [];
  if ((prop.pagination.current_page % visiblePagesCount.value) === 1 && startPage !== 1) {
     startPage-=1;
  }
  if ((prop.pagination.current_page % visiblePagesCount.value) === 0) {
     endPage+=1;
  }
  if ((prop.pagination.last_page - endPage) < visiblePagesCount.value) {
     endPage = prop.pagination.last_page;
  }
  for (let i = startPage; i <= endPage; i++) {
     visiblePages.push(i);
  } 
  return {visiblePages, startPage, endPage};
}; 
</script>
 