export interface Contact {
  name: string,
  number: string
}

export interface User extends Contact {
  id: string
}