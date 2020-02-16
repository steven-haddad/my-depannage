
class @PluginLoader
  constructor: (@formslider, @globalPluginConfig) ->
    @loaded = {}

  loadAll: (plugins) =>
    allPlugins = []
    for plugin in plugins
      unless window[plugin.class]
        @formslider.logger.warn("loadAll(#{plugin.class}) -> not found")
        continue

      allPlugins.push @load(plugin, false)

    for plugin in allPlugins
      plugin.init()

    return allPlugins # performance, dont return loops in coffee

  load: (plugin, initPlugin=true) =>
    PluginClass = window[plugin.class]

    unless plugin.config?
      config = @globalPluginConfig
    else
      config = ObjectExtender.extend(
        {},
        @globalPluginConfig,
        plugin.config
      )

    try
      pluginInstance = new PluginClass(@formslider, config, plugin.class)
      @loaded[plugin.class]   = pluginInstance
      pluginInstance.init() if initPlugin
      return pluginInstance

    catch error
      @formslider.logger.error("loadPlugin(#{plugin.class}) -> error", error)

  isLoaded: (name) =>
    name of @loaded

  get: (name) =>
    return unless @isLoaded(name)
    @loaded[name]
