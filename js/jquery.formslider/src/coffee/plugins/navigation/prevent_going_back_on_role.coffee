class @PreventGoingBackOnRole extends AbstractFormsliderPlugin
  @config = {}

  init: =>
    @on('leaving', @checkPermissions)

  checkPermissions: (event, current, direction, next) =>
    return unless direction == 'prev'

    currentRole = $(current).data('role')

    return unless currentRole

    return @cancel(event) if currentRole of @config
