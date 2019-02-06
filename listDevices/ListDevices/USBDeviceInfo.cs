using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace ListDevices
{
    public class USBDeviceInfo
    {
        public string DeviceID { get; }
        public string Name { get; }
        public string PnpDeviceID { get; }
        public string Description { get; }

        public USBDeviceInfo(string deviceID, string name)
        {
            this.DeviceID = deviceID;
            this.Name = name;
        }    
    }
}
