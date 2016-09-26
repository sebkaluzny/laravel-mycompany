export const indexElementTasks = state => {
    return state.elementTask.index.element_tasks
}

export const indexIsBusy = state => {
    return state.elementTask.index.busy
}


export const editModel = state => {
    return state.elementTask.edit.model
}
export const editIsBusy = state => {
    return state.elementTask.edit.busy
}
export const editForm = state => {
    return state.elementTask.edit.form
}


export const allTasks = state => {
    return state.elementTask.all
}