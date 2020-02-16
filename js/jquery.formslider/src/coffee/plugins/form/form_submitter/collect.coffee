class @FormSubmitterCollect extends FormSubmitterAbstract
  @config =
    infoInputSelector: 'input.info'
    inputFilter: (inputs) ->
      inputs['form_submitted_at'] = (new Date()).toISOString()
      inputs

  constructor: (@plugin, @config, @form) ->
    super(@plugin, @config, @form)
    @supressNaturalFormSubmit()

  submit: (event) =>
    inputs = @collectInputs()
    inputs = @config.inputFilter(inputs, @) if @config.inputFilter

    @plugin.onBeforeSubmit(inputs)
    $.ajax(
      cache:  false
      url:    @config.endpoint
      method: @config.method
      data:   inputs
    )
    .done(@plugin.onDone)
    .fail(@plugin.onFail)

  collectInputs: =>
    result = {}

    # all info inputs
    $inputs = $(@config.infoInputSelector)
    for input in $inputs
      $input = $(input)
      if $input.is(':checkbox')
        result[$input.prop('name')] = $input.val() if $input.is(':checked')
      else
        result[$input.prop('name')] = $input.val()

    # inputs on visited slides
    $container = $(".#{@plugin.config.slideVisitedClass}")

    $inputs = $('input, select, textarea', $container)
    for input in $inputs
      $input = $(input)
      if $input.is(':checkbox')
        if $input.is(':checked')
          name = $input.prop('name')
          unless result[$input.prop('name')]
            result[name] = $input.val()
          else
            result[name] = result[name] + ', ' + $input.val()

      else
        result[$input.prop('name')] = $input.val()

    return result
