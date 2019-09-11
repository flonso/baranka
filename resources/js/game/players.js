import Axios from 'axios';
import { handleError, handleSuccess } from './game'

export function initializeDataTables() {
    const table = $('#players').DataTable( {
      "ajax": "api/players?limit=1000",
      "deferRender": true,
      "columns": [
          { "data": "id"},
          { "data": "code" },
          { "data": "first_name" },
          { "data": "last_name" },
          { "data": "group" },
          { "data": "level"},
          { "data": "score" },
          {
              "data": "comments",
              "render": (data, type, row, meta) => {
                  const content = (data) ? data : ""
                  const html = (
                    `<form class="form-inline comment-form">` +
                      `<div class="form-group">` +
                        `<textarea class="form-control" rows="3" data-id="${row.id}">` +
                            content +
                        `</textarea>` +
                      `</div>` +
                      `<button type="button" class="btn btn-secondary">` +
                        `<i class="fas fa-save"></i>` +
                      `</button>` +
                    `</form>`
                  )
                  return html
              }
          }
      ]
  })

  table.on('draw', function () {
    const buttons = $('.comment-form button')

    buttons.off('click')
    buttons.click((event) => {
      event.preventDefault();
      const textarea = $(event.target).parent('form').find('textarea')
      const playerId = textarea.data('id')
      let comments = textarea.val()
      comments = (comments && comments.trim()) ? comments.trim() : null

      Axios.patch(
        `/api/players/${playerId}`,
        {
          comments: comments
        }
      ).then(
        (r) => handleSuccess(r)
      ).catch(handleError)
    })
  })

}