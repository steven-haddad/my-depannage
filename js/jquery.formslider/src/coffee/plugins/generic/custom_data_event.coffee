class @CustomDataEvent extends AbstractFormsliderPlugin
  init: =>
    @on('before',  @doBefore)
    @on('after',   @doAfter)
    @on('leaving', @doLeaving)
    @on('leaving-success', @doLeavingSuccess)

  doBefore: (event, current, direction, next) =>
    @doGeneric('before', event, current, direction, next)

  doAfter: (event, current, direction, prev) =>
    @doGeneric('after', event, current, direction, prev)

  doLeaving: (event, current, direction, next) =>
    @doGeneric('leaving', event, current, direction, next)

  doLeavingSuccess: (event, current, direction, next) =>
    @doGeneric('leaving-success', event, current, direction, next)

  doGeneric: (baseEvent, event, current, direction, next) =>
    data = $(current).data('custom-event')
    return unless data

    role = $(current).data('role')
    possibleEvents = [
      baseEvent,
      "#{baseEvent}.#{direction}"
      "#{baseEvent}.#{role}"
      "#{baseEvent}.#{direction}.#{role}"
      "#{baseEvent}.#{role}.#{direction}"
    ]

    for onEvent, triggerEvents of data
      if onEvent in possibleEvents
        for triggerEvent in triggerEvents
          @trigger(triggerEvent, current, onEvent)
