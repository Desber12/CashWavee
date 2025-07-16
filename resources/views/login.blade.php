<div className="flex items-center justify-center min-h-screen bg-white">
  <div className="flex flex-col items-center w-full">
    <Card className="w-[543px] rounded-[9px] shadow-[0px_4px_4px_#00000040] relative">
      <div className="relative">
        <Separator className="h-[3px] bg-[#f93c39] w-[529px] mx-auto" />
        <div className="p-8 pb-12">
          <div className="mb-12">
            <span className="text-[#f93c39] text-xs">
              <br />
            </span>
            <span className="[font-family:'Lexend_Deca-SemiBold',Helvetica] font-semibold text-[#f93c39] text-[32px]">
              Login
            </span>
          </div>

          <CardContent className="p-0 space-y-6">
            {formFields.map((field) => (
              <div key={field.id} className="space-y-2">
                <div
                  className={`[font-family:${field.id === "email" ? "'Exo_2-Medium'" : "'Exo-SemiBold'"},Helvetica] font-${field.id === "email" ? "medium" : "semibold"} text-black text-xl`}
                >
                  {field.label}
                </div>
                <Input
                  type={field.type}
                  className="h-[66px] bg-[#fefeff] borders-2 borders-[#edeffd] rounded"
                />
              </div>
            ))}

            <Button className="w-full h-[66px] mt-12 bg-[#f93c39] hover:bg-[#e03532] rounded shadow-[0px_4px_4px_#00000040]">
              <span className="[font-family:'Lexend_Deca-SemiBold',Helvetica] font-semibold text-white text-xl">
                Login
              </span>
            </Button>
          </CardContent>
        </div>
      </div>
    </Card>

    <div className="mt-16 [font-family:'Inter-SemiBold',Helvetica] font-semibold text-black text-xl">
      Copyright © CashWave
    </div>
  </div>
</div>