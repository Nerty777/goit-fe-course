import React from 'react'
import { connect } from 'react-redux'

import { User, AppStateType, AppDispatchType } from '../../types/types'
import actions from '../../redux/contacts/contacts-actions'
import { getContacts, getFilter } from '../../redux/contacts/contacts-selectors'

interface Props {
  changeFilter: (e: React.ChangeEvent<HTMLInputElement>) => void
  contacts: User[]
  value: string
}

const Filter = ({ contacts, value, changeFilter }: Props): JSX.Element => {
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

const mapStateToProps = (state: AppStateType) => ({
  contacts: getContacts(state),
  value: getFilter(state),
})

const mapDispatchToProps = (dispatch: AppDispatchType) => ({
  changeFilter: (e: React.ChangeEvent<HTMLInputElement>) =>
    dispatch(actions.changeFilter(e.target.value)),
})

export default connect(mapStateToProps, mapDispatchToProps)(Filter)
