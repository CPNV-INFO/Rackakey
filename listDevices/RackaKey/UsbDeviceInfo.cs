using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Management;

namespace RackaKey
{
    public class UsbDeviceInfo
    {
        public string DeviceID { get; private set; }
        public string PnpDeviceID { get; private set; }
        public string Description { get; private set; }
        public string Name { get; private set; }

        public string NumberOfPorts { get; private set; }

        public UsbDeviceInfo(string deviceID, string pnpDeviceID, string description, string name, string numberOfPorts)
        {
            this.DeviceID = deviceID;
            this.PnpDeviceID = pnpDeviceID;
            this.Description = description;
            this.Name = name;
            this.NumberOfPorts = numberOfPorts;
        }
    }
}
