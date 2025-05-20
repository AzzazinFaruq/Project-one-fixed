import { defineStore } from 'pinia'

export const useTitle = defineStore('title', {
  state: () => ({
    pageTitle: ''
  }),
  actions: {
    setTitle(title) {
      this.pageTitle = title
    }
  }
}) 
