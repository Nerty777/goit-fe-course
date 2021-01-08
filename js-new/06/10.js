import users from './users.js'

const getSortedUniqueSkills = users => {
  return users
    .reduce((acc, user) => {
      return [...acc, ...user.skills]
    }, [])
    .filter((el, ind, arr) => arr.indexOf(el) === ind)
    .sort()
}

console.log(getSortedUniqueSkills(users))
console.log('users: ', users)
// [ 'adipisicing', 'amet', 'anim', 'commodo', 'culpa', 'elit', 'ex', 'ipsum', 'irure', 'laborum', 'lorem', 'mollit', 'non', 'nostrud', 'nulla', 'proident', 'tempor', 'velit', 'veniam' ]
