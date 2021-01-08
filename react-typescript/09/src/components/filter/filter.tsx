import { useDispatch, useSelector } from 'react-redux'

import actions from '../../redux/contacts/contacts-actions'
import { getContacts, getFilter } from '../../redux/contacts/contacts-selectors'

export default function Filter(): JSX.Element {
  const dispatch = useDispatch()
  const contacts = useSelector(getContacts)
  const value = useSelector(getFilter)

  const changeFilter = (e: React.ChangeEvent<HTMLInputElement>) => (
    dispatch(actions.changeFilter(e.target.value))
  )

  return (
    <>
      {contacts.length > 1 && (
        <label htmlFor="filter">
          <p>Find contacts by name</p>
          <input
            type="text"
            value={value}
            name="filter"
            id="filter"
            onChange={changeFilter}
          />
        </label>
      )}
      {!contacts.length && <h3>No contacts found</h3>}
    </>
  )
}
