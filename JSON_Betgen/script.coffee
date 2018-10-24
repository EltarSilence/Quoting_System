EXACT = ["10","9.5","9","8.5","8","7.5","7","6.5","6","5.5","5","4.5","4","3.5","3","2","1"]
UNDER = ["9.25","8.75","8.25","7.75","7.25","6.75","6.25","5.75","5.25","4.75","4.25","3.75","3.25","3","2"]
OVER = ["9.25","8.75","8.25","7.75","7.25","6.75","6.25","5.75","5.25","4.75","4.25","3.75","3.25", "3", "2"]
low = 0.67

factorial = (num) ->
  if num is 0 then return 1
  rval = 1
  for i in [2 .. num]
    rval*=i
  rval

simple_poisson = (vm, va) ->
  prob = (Math.pow(vm,va)*Math.pow(Math.E,-vm))/(factorial(va))
  q = 1/prob
  q*low

LnFact = (x) ->
  if x <= 1
    x = 1
  if x < 12
    Math.log factorial(Math.round(x))
  else
    invx = 1 / x
    invx2 = invx * invx
    invx3 = invx2 * invx
    invx5 = invx3 * invx2
    invx7 = invx5 * invx2
    sum = (x + 0.5) * Math.log(x) - x
    sum += Math.log(2 * Math.PI) / 2
    sum += invx / 12 - (invx3 / 360)
    sum += invx5 / 1260 - (invx7 / 1680)
    sum

NormalP = (x) ->
  d1 = 0.0498673470
  d2 = 0.0211410061
  d3 = 0.0032776263
  d4 = 0.0000380036
  d5 = 0.0000488906
  d6 = 0.0000053830
  a = Math.abs(x)
  t = undefined
  t = 1.0 + a * (d1 + a * (d2 + a * (d3 + a * (d4 + a * (d5 + a * d6)))))
  t *= t
  t *= t
  t *= t
  t *= t
  t = 1.0 / (t + t)
  if x >= 0
    t = 1 - t
  t

PoissonPD = (u, k) ->
  s = k + 1 / 2
  d1 = k + 2 / 3 - u
  d2 = d1 + 0.02 / (k + 1)
  z = (1 + g(s / u)) / u
  z = d2 * Math.sqrt(z)
  z = NormalP(z)
  z

PoissonTerm = (u, k) ->
  Math.exp k * Math.log(u) - u - LnFact(k)

PoissonCTF = (u, k) ->
  if k >= 20
    PoissonPD u, k
  else
    sum = 0.0
    j = 0
    while j <= k
      sum += PoissonTerm(u, j++)
    if sum > 1
      sum = 1
    1/sum

inverse = (q) ->
  (100/(100-(100/q))).toFixed 2

generateQ = (s) ->
  m = document.getElementById(s).value
  json = s+':'+'{'+'"Esatto":{'
  for ex in EXACT
    json+= '"'+ex+'"'+':'+simple_poisson(m, ex).toFixed(2)+', '

  json = json.substring(0, json.length-2)
  json += '}'
  json += ' "Under":{'

  for un in UNDER
    json+= '"'+un+'"'+':'+PoissonCTF(m, un).toFixed(2)+', '

  json = json.substring(0, json.length-2)
  json += '}'
  json += ' "Over":{'

  for ov in OVER
    json+= '"'+ov+'"'+':'+inverse(PoissonCTF(m, ov).toFixed(2))+', '
  json = json.substring(0, json.length-2)
  json += '}' + '},'
  
  document.getElementById("result").innerHTML += json + ''
  document.getElementById(s).setAttribute("disabled", "true")
