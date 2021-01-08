class Storage {
  constructor(items = []) {
    this.items = items
  }

  getItems() {
    return this.items
  }

  addItem(item) {
    this.items.push(item)
  }

  removeItem(name) {
    this.items = this.items.filter(item => item !== name)
  }
}

const storage = new Storage([
  'Нанитоиды',
  'Пролонгер',
  'Железные жупи',
  'Антигравитатор',
])

const items = storage.getItems()
console.table(items) // [ "Нанитоиды", "Пролонгер", "Железные жупи", "Антигравитатор" ]

storage.addItem('Дроид')
console.table(storage.items) // [ "Нанитоиды", "Пролонгер", "Железные жупи", "Антигравитатор", "Дроид" ]

storage.removeItem('Пролонгер')
console.table(storage.items) // [ "Нанитоиды", "Железные жупи", "Антигравитатор", "Дроид" ]
