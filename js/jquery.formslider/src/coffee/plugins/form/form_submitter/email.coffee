class @FormSubmitterEmail extends FormSubmitterAbstract
  @config =
    submitButtonSelector: '.slide-role-contact .next-button'
    mailto: 'hello@slidevision.io'
    subject: 'Hey There!'
    body: 'Tell us your story =)'
    validatorPlugin: 'JqueryInputValidator'
    validateSlideRole: 'contact'
    inputSelector: 'input.info'

  constructor: (@plugin, @config, @form) ->
    super(@plugin, @config, @form)
    @supressNaturalFormSubmit()

    @validator = @plugin.formslider.plugins.get(@config.validatorPlugin)

    $('body').on('click', @config.submitButtonSelector, (e) =>
      contactSlide = @plugin.slideByRole(@config.validateSlideRole)
      if @validator.validate(contactSlide) != true
        e.preventDefault()
        return false

      $target = $(e.currentTarget)
      $target.attr('href', @generateHref())
    )

  submit: (event, slide) ->


  generateHref: =>
    inputs  = @collectInputs()
    message = @config.body + "\n\nYour answers:\n\n" + @formatInputs(inputs)
    message = encodeURIComponent(message)

    subject = @config.subject
    subject = encodeURIComponent(subject)

    "mailto:#{@config.mailto}?subject=#{subject}&body=#{message}"

  formatInputs: (inputs) ->
    directMapping = {}
    for key, value of inputs
      if key.indexOf('_answer') > -1
        key = key.replace('_answer', '')
        directMapping[key] = {} unless directMapping?[key]
        directMapping[key].answer = value
      else
        directMapping[key] = {} unless directMapping?[key]
        directMapping[key].question = value

    result = ''
    for key, value of directMapping
      if value?.answer
        result += "  #{value.question}: #{value.answer}"
      else
        result += "  #{key}: #{value.question}"

      result += "\n"

    result

  collectInputs: =>
    result = {}

    # all info inputs
    $inputs = $(@config.inputSelector, $container)
    for input in $inputs
      $input = $(input)
      result[$input.attr('name')] = $input.val()

    # inputs on visited slides
    $container = $(".#{@plugin.config.slideVisitedClass}", $container)
    $inputs = $('input, select, textarea', $container)
    for input in $inputs
      $input = $(input)
      if $input.is(':checkbox')
        result[$input.attr('name')] = $input.val() if $input.is(':checked')

      else
        result[$input.attr('name')] = $input.val()

    return result
