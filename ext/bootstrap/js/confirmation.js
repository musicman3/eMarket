  $('[data-toggle=confirmation]').confirmation();
  $('[data-toggle=confirmation-singleton]').confirmation({ singleton: true });
  $('[data-toggle=confirmation-popout]').confirmation({ popout: true });

  $('[data-toggle=confirmation-custom]').confirmation({
    buttons: [
      {
        label: 'Approved',
        class: 'btn btn-xs btn-success',
        icon: 'glyphicon glyphicon-ok'
      },
      {
        label: 'Rejected',
        class: 'btn btn-xs btn-danger',
        icon: 'glyphicon glyphicon-remove'
      },
      {
        label: 'Need review',
        class: 'btn btn-xs btn-warning',
        icon: 'glyphicon glyphicon-search'
      },
      {
        label: 'Decide later',
        class: 'btn btn-xs btn-default',
        icon: 'glyphicon glyphicon-time'
      }
    ]
  });